
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $title ?></title>

        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/highcharts.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery1.6.1.js') ?>"></script>
        <script src="<?php echo base_url('assets/jquery-ui-1.10.4.custom.min.js') ?>"></script>

        <link rel="icon" href="<?php echo base_url('assets/img/LogoAisin.png'); ?>" > 
        <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace-theme-minimal.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck/skins/square/blue.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/switchery/switchery.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2-bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-slider/css/slider.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-datatables/css/dataTables.bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-niftymodal/css/component.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-gritter/css/jquery.gritter.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/skins.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" >
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.tableTools.css'); ?>">
        <script src="http://192.168.0.234:8080/socket.io/socket.io.js"></script>
        <link href="http://192.168.0.234:8080/css/bootstrap.css" rel="stylesheet">
        <link href="http://192.168.0.234:8080/css/main.css" rel="stylesheet">


        <style type="text/css">
            /*body {
                background:#1f1f1f;
                font-family: 'Open Sans', sans-serif;
            }*/
            body {
                padding-top: 80px;
                max-height: 100%;
            }
            html{
                background:#1f1f1f;
            }
        </style>

        <style>
            #footerwrap {
                /*position: fixed;*/
                bottom: 0;
            }
            .dropbtn {
                background-color: #252525;
                color: #9A9791;
                padding: 15px;
                font-size: 15px;
                border: none;
                cursor: pointer;
            }
            
            .dropbtn:hover, .dropbtn:focus {
                color: white;
                /* background-color:black; */
                outline: none;
            }
            
            .dropdown {
                position: relative;
                display: inline-block;
            }
            
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #ffffff;
                min-width: 160px;
                overflow: auto;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }
            
            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            .half-unit{
                height: 490px;
                width: 100%;
                
            }

            .imgcctv{

                display: block;
                alignment-adjust: middle;
                width: 100%;
                height: 390px;
                margin: 0 auto;
                border: 0;
                text-align: center
            }
            .cont{
                top:0px;
                bottom: 0px;
            }
            .dropdown a:hover {background-color: #f1f1f1}
            
            .show {display:block;}

            span{
                font-size: 16px;
            }
            iframe {
                display: block;
                alignment-adjust: middle;
                width: 100%;
                height: 300px;
                margin: 0 auto;
                border: 0;
                text-align: center
            }
        </style>
        
    </head>
    <body>

        <script>
            /* When the user clicks on the button, 
            toggle between hiding and showing the dropdown content */
            function myFunction_unitpart() {
                document.getElementById("ddUnitPart").classList.add("active");
                document.getElementById("ddBodyPart").classList.remove("active");
                document.getElementById("ddInjection").classList.remove("active");
                document.getElementById("ddDoorLock").classList.remove("active");
                document.getElementById("ddDoorFrame").classList.remove("active");
                document.getElementById("ddStamping").classList.remove("active");
                // Unitparts
                document.getElementById("unitparts").style.display='block';
                document.getElementById("bodyparts").style.display='none';
                document.getElementById("doorlock").style.display='none';
                document.getElementById("doorframe").style.display='none';
                document.getElementById("injection").style.display='none';
                document.getElementById("stamping").style.display='none';
                // UnitPart
                // document.getElementById('ASCC').src = 'http://192.168.0.221:8080/mjpegfeed?oid=11&full';
                // document.getElementById('ASCC03').src = 'http://192.168.0.221:8080/mjpegfeed?oid=15&full';
                // document.getElementById('ASCH01').src = 'http://192.168.0.221:8080/mjpegfeed?oid=14&full';
                // document.getElementById('ASCD').src = 'http://192.168.0.221:8080/mjpegfeed?oid=10&full';
                // document.getElementById('ASIM').src = 'http://192.168.0.221:8080/mjpegfeed?oid=5&full';
                // document.getElementById('ASCD02').src = 'http://192.168.0.221:8080/mjpegfeed?oid=12&full';

                document.getElementById('ASCC').src = 'http://192.168.0.221:81/mjpg/ASCC01/video.mjpg';
                document.getElementById('ASCC03').src = 'http://192.168.0.221:81/mjpg/ASCC03/video.mjpg';
                document.getElementById('ASCH01').src = 'http://192.168.0.221:81/mjpg/ASCH01/video.mjpg';
                document.getElementById('ASCD').src = 'http://192.168.0.221:81/mjpg/ASCD01/video.mjpg';
                document.getElementById('ASIM').src = 'http://192.168.0.221:81/mjpg/ASIM02/video.mjpg';
                document.getElementById('ASCD02').src = 'http://192.168.0.221:81/mjpg/ASCD02/video.mjpg';
                document.getElementById('ASCC05').src = 'http://192.168.0.221:81/mjpg/ASCC05/video.mjpg';
                // Bodyparts
                document.getElementById('ASCA01').src = '';
                // DoorLock
                document.getElementById('ASDL09').src = '';
                document.getElementById('ASDL05').src = '';
                document.getElementById('ASDL03').src = '';
                document.getElementById('ASDL07').src = '';
                // Doorframe
                document.getElementById('ASDF09').src = '';
                document.getElementById('ASDF03').src = '';
                // Injection
                document.getElementById('').src = '';
                // Stamping
                document.getElementById('').src = '';
            }

            function myFunction_bodypart() {
                document.getElementById("ddBodyPart").classList.add("active");
                document.getElementById("ddUnitPart").classList.remove("active");
                document.getElementById("ddInjection").classList.remove("active");
                document.getElementById("ddDoorLock").classList.remove("active");
                document.getElementById("ddDoorFrame").classList.remove("active");
                document.getElementById("ddStamping").classList.remove("active");

                document.getElementById("unitparts").style.display='none';
                document.getElementById("bodyparts").style.display='block';
                document.getElementById("doorlock").style.display='none';
                document.getElementById("doorframe").style.display='none';
                document.getElementById("injection").style.display='none';
                document.getElementById("stamping").style.display='none';
                
                // UnitPart
                document.getElementById('ASCC').src = '';
                document.getElementById('ASCD').src = '';
                document.getElementById('ASIM').src = '';
                document.getElementById('ASCD02').src = '';
                // Bodyparts
                document.getElementById('ASCA01').src = 'http://192.168.0.221:81/mjpg/ASCA02/video.mjpg';
                // document.getElementById('ASCA01').src = 'http://192.168.0.221:81/mjpg/ASCA02/video.mjpg';
                document.getElementById('ASRH01').src = 'http://192.168.0.221:81/mjpg/ASRH01/video.mjpg';
                // DoorLock
                document.getElementById('ASDL09').src = '';
                document.getElementById('ASDL05').src = '';
                document.getElementById('ASDL03').src = '';
                document.getElementById('ASDL07').src = '';
                // Doorframe
                document.getElementById('ASDF09').src = '';
                document.getElementById('ASDF03').src = '';
                // Injection
                document.getElementById('').src = '';
                // Stamping
                document.getElementById('').src = '';
            }

            function myFunction_doorlock() {
                document.getElementById("ddDoorLock").classList.add("active");
                document.getElementById("ddUnitPart").classList.remove("active");
                document.getElementById("ddInjection").classList.remove("active");
                document.getElementById("ddBodyPart").classList.remove("active");
                document.getElementById("ddDoorFrame").classList.remove("active");
                document.getElementById("ddStamping").classList.remove("active");

                document.getElementById("unitparts").style.display='none';
                document.getElementById("bodyparts").style.display='none';
                document.getElementById("doorlock").style.display='block';
                document.getElementById("doorframe").style.display='none';
                document.getElementById("injection").style.display='none';
                document.getElementById("stamping").style.display='none';
                // UnitPart
                document.getElementById('ASCC').src = '';
                document.getElementById('ASCD').src = '';
                document.getElementById('ASIM').src = '';
                document.getElementById('ASCD02').src = '';
                // Bodyparts
                document.getElementById('ASCA01').src = '';
                // DoorLock
                document.getElementById('ASDL09').src = 'http://192.168.0.221:81/mjpg/ASDL09/video.mjpg';
                document.getElementById('ASDL05').src = 'http://192.168.0.221:81/mjpg/ASDL05/video.mjpg';
                document.getElementById('ASDL03').src = 'http://192.168.0.221:81/mjpg/ASDL03/video.mjpg';
                document.getElementById('ASDL07').src = 'http://192.168.0.221:81/mjpg/ASDL07/video.mjpg';
                // Doorframe
                document.getElementById('ASDF09').src = '';
                document.getElementById('ASDF03').src = '';
                // Injection
                document.getElementById('').src = '';
                // Stamping
                document.getElementById('').src = '';

            }
            function myFunction_doorframe() {
                document.getElementById("ddDoorFrame").classList.add("active");
                document.getElementById("ddUnitPart").classList.remove("active");
                document.getElementById("ddInjection").classList.remove("active");
                document.getElementById("ddBodyPart").classList.remove("active");
                document.getElementById("ddDoorLock").classList.remove("active");
                document.getElementById("ddStamping").classList.remove("active");

                document.getElementById("unitparts").style.display='none';
                document.getElementById("bodyparts").style.display='none';
                document.getElementById("doorlock").style.display='none';
                document.getElementById("doorframe").style.display='block';
                document.getElementById("injection").style.display='none';
                document.getElementById("stamping").style.display='none';
                // UnitPart
                document.getElementById('ASCC').src = '';
                document.getElementById('ASCD').src = '';
                document.getElementById('ASIM').src = '';
                document.getElementById('ASCD02').src = '';
                // Bodyparts
                document.getElementById('ASCA01').src = '';
                // DoorLock
                document.getElementById('ASDL09').src = '';
                document.getElementById('ASDL05').src = '';
                document.getElementById('ASDL03').src = '';
                document.getElementById('ASDL07').src = '';
                // Doorframe
                document.getElementById('ASDF09').src = 'http://192.168.0.221:81/mjpg/ASDF09/video.mjpg';
                document.getElementById('ASDF03').src = 'http://192.168.0.221:81/mjpg/ASDF05/video.mjpg';
                document.getElementById('RFDF05').src  = 'http://192.168.0.221:81/mjpg/RFDF05/video.mjpg';
                
                // Injection
                document.getElementById('').src = '';
                // Stamping
                document.getElementById('').src = '';
                document.getElementById('').src = '';
                document.getElementById('').src = '';
            }

            function myFunction_injection() {
                document.getElementById("ddInjection").classList.add("active");
                document.getElementById("ddUnitPart").classList.remove("active");
                document.getElementById("ddDoorLock").classList.remove("active");
                document.getElementById("ddBodyPart").classList.remove("active");
                document.getElementById("ddDoorFrame").classList.remove("active");
                document.getElementById("ddStamping").classList.remove("active");

                document.getElementById("unitparts").style.display='none';
                document.getElementById("bodyparts").style.display='none';
                document.getElementById("doorlock").style.display='none';
                document.getElementById("doorframe").style.display='none';
                document.getElementById("injection").style.display='block';
                document.getElementById("stamping").style.display='none';
                // UnitPart
                document.getElementById('ASCC').src = '';
                document.getElementById('ASCD').src = '';
                document.getElementById('ASIM').src = '';
                document.getElementById('ASCD02').src = '';
                // Bodyparts
                document.getElementById('ASCA01').src = '';
                // DoorLock
                document.getElementById('ASDL09').src = '';
                document.getElementById('ASDL05').src = '';
                document.getElementById('ASDL03').src = '';
                document.getElementById('ASDL07').src = '';
                // Doorframe
                document.getElementById('ASDF09').src = '';
                document.getElementById('ASDF03').src = '';
                // Injection
                document.getElementById('PC003I').src = 'http://192.168.0.221:81/mjpg/PC003I/video.mjpg';
                document.getElementById('PC001A').src = 'http://192.168.0.221:81/mjpg/PC001A/video.mjpg';
                document.getElementById('PC003F').src = 'http://192.168.0.221:81/mjpg/PC003F/video.mjpg';
                // Stamping
                document.getElementById('').src = '';
                document.getElementById('').src = '';
                document.getElementById('').src = '';
            }
            function myFunction_stamping() {
                document.getElementById("ddInjection").classList.remove("active");
                document.getElementById("ddStamping").classList.add("active");
                document.getElementById("ddUnitPart").classList.remove("active");
                // document.getElementById("ddEngine").classList.remove("active");
                document.getElementById("ddDoorLock").classList.remove("active");
                document.getElementById("ddBodyPart").classList.remove("active");
                document.getElementById("ddDoorFrame").classList.remove("active");

                document.getElementById("unitparts").style.display='none';
                document.getElementById("bodyparts").style.display='none';
                document.getElementById("doorlock").style.display='none';
                document.getElementById("doorframe").style.display='none';
                document.getElementById("injection").style.display='none';
                document.getElementById("stamping").style.display='block';
                // UnitPart
                document.getElementById('ASCC').src = '';
                document.getElementById('ASCD').src = '';
                document.getElementById('ASIM').src = '';
                document.getElementById('ASCD02').src = '';
                // Bodyparts
                document.getElementById('ASCA01').src = '';
                // DoorLock
                document.getElementById('ASDL09').src = '';
                document.getElementById('ASDL05').src = '';
                document.getElementById('ASDL03').src = '';
                document.getElementById('ASDL07').src = '';
                // Doorframe
                document.getElementById('ASDF09').src = '';
                document.getElementById('ASDF03').src = '';
                // Injection
                // document.getElementById('').src = '';
                // Stamping
                document.getElementById('PR003A').src  = 'http://192.168.0.221:81/mjpg/PR003A/video.mjpg';
                document.getElementById('PR6HI').src = 'http://192.168.0.221:81/mjpg/PR006H/video.mjpg';
                document.getElementById('PR6Q').src  = 'http://192.168.0.221:81/mjpg/PR006Q/video.mjpg';
            }
            
            
        </script>
        
        <!-- NAVIGATION MENU -->
        <div class="navbar-nav navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><img src="http://192.168.0.234:8080/img/logo30.png" alt=""></a>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <div class="dropdown" class="active" id="ddUnitPart">
                            <button onclick="myFunction_unitpart()" class="dropbtn">Unit Parts</button>
                        </div>
                        <div class="dropdown" id="ddBodyPart">
                            <button onclick="myFunction_bodypart()" class="dropbtn">Body Parts</button>
                        </div>
                        <div class="dropdown" id="ddDoorLock">
                            <button onclick="myFunction_doorlock()" class="dropbtn">Door Lock</button>
                        </div>
                        <div class="dropdown" id="ddDoorFrame"> 
                            <button onclick="myFunction_doorframe()" class="dropbtn">Door Frame</button>
                        </div>
                        <div class="dropdown" id="ddInjection">
                            <button onclick="myFunction_injection()" class="dropbtn">Injection</button>
                        </div>
                        <div class="dropdown" id="ddStamping">
                            <button onclick="myFunction_stamping()" class="dropbtn">Stamping</button>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container">
            <div class="row" id="unitparts" style="display: block;">
                <div class="col-sm-6 col-lg-6">
                    <!-- ASCC01 -->
                    <div class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-ascc01">
                            <br><center><span><b>ASCC01 - ASCC02 - ASCC03</b></span></center>
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img src="http://192.168.0.221:81/mjpg/ASCC01/video.mjpg" id="ASCC" class="imgcctv">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <!-- ASCD01 -->
                    <div class="half-unit" id="half-unit-ascd01">
                        <dtitle id="ot-ascd01">
                            <br><center><span><b>ASCD01 - ASCD02 - ASCD03</b></span></center>
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img id="ASCD" class="imgcctv" src="http://192.168.0.221:81/mjpg/ASCD01/video.mjpg" align="middle" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-ascc03"><center><span><b>ASCC03 - ASCC04</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img id="ASCC03" class="imgcctv" src="http://192.168.0.221:81/mjpg/ASCC03/video.mjpg" align="middle" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-ascc03"><center><span><b>ASCC05</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img id="ASCC05" class="imgcctv" src="http://192.168.0.221:81/mjpg/ASCC05/video.mjpg" align="middle" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <!-- ASCD02 -->
                    <div class="half-unit" id="half-unit-ascd01">
                        <dtitle id="ot-ascd02">
                            <br><center><span><b>ASCD02 (OGAWA CD)</b></span></center>
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img id="ASCD02" class="imgcctv" src="http://192.168.0.221:81/mjpg/ASCD02/video.mjpg" align="middle" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <!-- ASCC03 -->
                    <div class="half-unit" id="half-unit-ascd01">
                        <dtitle id="ot-asim01">
                            <br><center><span><b>ASIM01 - ASIM02</b></span></center>
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img id="ASIM" class="imgcctv" src="http://192.168.0.221:81/mjpg/ASIM02/video.mjpg" align="middle" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <!-- ASCH01 -->
                    <div class="half-unit" id="half-unit-ascd01">
                        <dtitle id="ot-asch01">
                            <br><center><span><b>ASCH01</b></span></center>
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img id="ASCH01" class="imgcctv" src="http://192.168.0.221:81/mjpg/ASCH01/video.mjpg" align="middle" >
                        </div>
                    </div>
                </div>                 
            </div>
            <!-- Body Part -->
            <div class="row" id="bodyparts" style="display: none;">
                <div class="col-sm-6 col-lg-6">
                    <div class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-asca01"><center><span><b>ASCA02 - ASHL01</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASCA01"  src="" class="imgcctv" align="middle" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-asrh01"><center><span><b>ASRH01 - ASDH01 - ASDH02</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASRH01"  src="" class="imgcctv" align="middle" >
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- DoorLock -->
            <div class="row" id="doorlock" style="display: none;">
                <div class="col-sm-6 col-lg-6">

                    <!-- ASCC01 -->
                    <div class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-asdl09"><center><span><b>ASDL09 - ASDL10</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASDL09"  src="" class="imgcctv" >
                           
                        </div>
                    </div>
                    <div class="half-unit" id="half-unit-ascd01">
                        <dtitle id="ot-asdl05"><center><span><b>SADL07 - ASDL05</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASDL05" src="" class="imgcctv"  >
                        </div>
                    </div>

                </div><!-- /col-sm-3 col-lg-3 -->
                <div class="col-sm-6 col-lg-6">
                    <!-- ASCD01 -->
                    <div class="half-unit" id="half-unit-ascd01">
                        <dtitle id="ot-asdl03"><center><span><b>ASDL03 - ASDL04</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASDL03"  src="" class="imgcctv"  >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <!-- ASCD01 -->
                    <div  class="half-unit" id="half-unit-ascd01">
                        <dtitle id="ot-asdl07"><center><span><b>ASDL07 - ASDL08</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASDL07" src="" class="imgcctv"  >
                        </div>
                    </div>
                </div>
            </div>
            <!-- Door Frame -->
            <div class="row" id="doorframe" style="display: none;">
                <div class="col-sm-6 col-lg-6">
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-asdf09"><center><span><b>ASDF05 - ASDF06</b></span></center>
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASDF03"  src="" class="imgcctv"  >
                        </div>
                    </div>
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-rfdf05"><center><span><b>RFDF05</b></span></center>
                        </dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="RFDF05"  src="" class="imgcctv"  >
                        </div>
                    </div>
                </div><!-- /col-sm-3 col-lg-3 -->
                <div class="col-sm-6 col-lg-6">
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-asdf05"><center><span><b>ASDF07 - ASDF08 - ASDF09</b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img  id="ASDF09"  src="" class="imgcctv"  >
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Injection -->
            <div class="row" id="injection" style="display: none;">
                <div class="col-sm-6 col-lg-6">
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-ascc01"><center><span><b> PC003I </b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img scrolling="no" id="PC003I" frameBorder="0" class="imgcctv" src="" align="middle" >
                        </div>
                    </div>
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-ascc01"><center><span><b> INJECTION 70 TON </b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img scrolling="no" id="PC001A" frameBorder="0" class="imgcctv" src="" align="middle" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div  class="half-unit" id="half-unit-ascc01">
                        <dtitle id="ot-ascc01"><center><span><b> PC003F </b></span></center></dtitle>
                        <hr>
                        <div class="cont">
                            <img scrolling="no" id="PC003F" frameBorder="0" class="imgcctv" src="" align="middle" >
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stamping -->
            <div class="row" id="stamping" style="display: none;">
                <div class="col-sm-6 col-lg-6">
                        <div  class="half-unit" id="half-unit-ascc01">
                            <dtitle id="ot-ctyp"><center><span><b>STAMPING C-TYPE</b></span></center>
                            </dtitle>
                            <hr>
                            <div class="cont">
                                <img  id="PR003A"  src="" class="imgcctv"  >
                            </div>
                        </div>
                        <div  class="half-unit" id="half-unit-ascc01">
                            <dtitle id="ot-ctyp"><center><span><b>PR006Q</b></span></center>
                            </dtitle>
                            <hr>
                            <div class="cont">
                                <img  id="PR6Q"  src="" class="imgcctv"  >
                            </div>
                        </div>
                    </div><!-- /col-sm-3 col-lg-3 -->
                    <div class="col-sm-6 col-lg-6">
                        <div  class="half-unit" id="half-unit-ascc01">
                            <dtitle id="ot-pr006hi"><center><span><b>PR006H - PR006I</b></span></center></dtitle>
                            <hr>
                            <div class="cont">
                                <img  id="PR6HI"  src="" class="imgcctv"  >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div id="footerwrap" class="foote">
            <?php $tanggal = getDate(); 
            ?>
            <div class="col-sm-6 col-lg-12">
                <p>Developed by MIS @<?php echo $tanggal['year'] ?></p>
            </div>  
        </div>


</body>
</html>